<?php
// @phpstan-ignore-next-line
use MongoDB\Collection;
// @phpstan-ignore-next-line
use MongoDB\BSON\UTCDateTime;

class StatsService
{
    // @phpstan-ignore-next-line
    private Collection $ordersCollection;

    public function __construct()
    {
        $this->ordersCollection = MongoDBConnection::getCollection('orders');
    }

    // Insérer une commande acceptée
    public function insertOrder(array $order): void
    {
        $this->ordersCollection->insertOne([
            'order_id'               => $order['order_id'],
            'menu_id'                => $order['menu_id'],
            'menu_title'             => $order['menu_title'],
            'nb_persons'             => (int) $order['nb_persons'],
            'calculated_menu_price'  => (float) $order['calculated_menu_price'],
            'delivery_fees'          => (float) $order['delivery_fees'],
            'discount'               => (float) $order['discount'],
            'total_price'            => (float) $order['total_price'],
            'event_date'             => $order['event_date'],
            // @phpstan-ignore-next-line
            'validated_at'           => new UTCDateTime()
        ]);
    }

    // Nombre de commandes totale
    public function getOrderCountTotal(): int
    {
        return (int) $this->ordersCollection->countDocuments();
    }

    // Nombre de commandes par menu
    public function getOrderCountByMenu(?string $dateFrom = null, ?string $dateTo = null): array
    {
        $pipeline = [];

        //Filtre par période
        $match = [];

        if ($dateFrom) {
            $match['event_date']['$gte'] = $dateFrom;
        }
        if ($dateTo) {
            $match['event_date']['$lte'] = $dateTo;
        }

        if (!empty($match)) {
            $pipeline[] = ['$match' => $match];
        }

        $pipeline[] = ['$group' => [
            '_id'   => '$menu_title',
            'count' => ['$sum' => 1],
            'total' => ['$sum' => '$total_price']
        ]];

        $pipeline[] = ['$sort' => ['count' => -1]];

        return $this->ordersCollection->aggregate($pipeline)->toArray();
    }

    //Menu le plus commandé
    public function getMostOrderedMenu(): array 
    {
        $pipeline = [
            ['$group' => [
                '_id' => '$menu_title',
                'count' => ['$sum' => 1]
            ]],
            ['$sort' =>['count' => -1]],
            ['$limit' => 1]
        ];

        $result = $this->ordersCollection->aggregate($pipeline)->toArray();

        if (empty($result)) return [];

        //Récupérer le nombre max
        $maxCount = $result[0]['count'];

        //Récupérer tous les menus ayant ce nombre max
        $pipeline = [
            ['$group' => [
                '_id' => '$menu_title',
                'count' => ['$sum' => 1]
            ]],
            ['$match' => ['count' => $maxCount]],
            ['$sort' => ['_id' => 1]]
        ];
        return $this->ordersCollection->aggregate($pipeline)->toArray();
    }

    // CA total
    public function getTotalRevenue(): float
    {
        $pipeline = [];

        $pipeline[] = ['$group' => [
            '_id' => null,
            'total' => ['$sum' => '$total_price']
        ]];

        $result = $this->ordersCollection->aggregate($pipeline)->toArray();

        if (empty($result)) {
            return 0.0;
        }

        return (float) ($result[0]['total'] ?? 0.0);
        
    }

    // CA par menu avec filtre période
    public function getRevenueByMenu(?string $menuId = null, ?string $dateFrom = null, ?string $dateTo = null): array
    {
        $match = [];

        if ($menuId) {
            $match['menu_id'] = (int) $menuId;
        }
        if ($dateFrom) {
            $match['event_date']['$gte'] = $dateFrom;
        }
        if ($dateTo) {
            $match['event_date']['$lte'] = $dateTo;
        }

        $pipeline = [];

        if (!empty($match)) {
            $pipeline[] = ['$match' => $match];
        }

        $pipeline[] = ['$group' => [
            '_id' => ['menu_id' => '$menu_id', 'menu_title' => '$menu_title'],
            'total' => ['$sum' => '$total_price'],
            'count' => ['$sum' => 1],
            'nb_orders' => ['$sum' => 1],
            'avg_price' => ['$avg' => '$total_price']
        ]];

        $pipeline[] = ['$sort' => ['total' => -1]];

        return $this->ordersCollection->aggregate($pipeline)->toArray();
    }

    //CA par mois (pour graphique en barre par période)
    public function getRevenueByMonth(?string $dateFrom = null, ?string $dateTo = null): array
    {
        $pipeline = [];

        $match = [];
        if ($dateFrom) $match['event_date']['$gte'] = $dateFrom;
        if ($dateTo)   $match['event_date']['$lte'] = $dateTo;
        if (!empty($match)) $pipeline[] = ['$match' => $match];

        $pipeline[] = ['$group' => [
            '_id'   => ['$substr' => ['$event_date', 0, 7]], // → "2026-08"
            'total' => ['$sum' => '$total_price'],
            'count' => ['$sum' => 1]
        ]];

        $pipeline[] = ['$sort' => ['_id' => 1]];

        return $this->ordersCollection->aggregate($pipeline)->toArray();
    }

    //CA par menu par mois (pour le graphique en ligne avec option menu)
    public function getRevenueByMenuAndMonth(?string $dateFrom = null, ?string $dateTo = null): array
    {
        $pipeline = [];

        $match = [];
        if ($dateFrom) $match['event_date']['$gte'] = $dateFrom;
        if ($dateTo)   $match['event_date']['$lte'] = $dateTo;
        if (!empty($match)) $pipeline[] = ['$match' => $match];

        $pipeline[] = ['$group' => [
            '_id' => [
                'month'      => ['$substr' => ['$event_date', 0, 7]],
                'menu_title' => '$menu_title'
            ],
            'total' => ['$sum' => '$total_price']
        ]];

        $pipeline[] = ['$sort' => ['_id.month' => 1]];

        return $this->ordersCollection->aggregate($pipeline)->toArray();
    }
}