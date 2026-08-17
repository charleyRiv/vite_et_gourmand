<?php
// @phpstan-ignore-next-line
use MongoDB\Collection;
use MongoDB\BSON\UTCDateTime;

class StatsService
{
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
            'nb_persons'             => $order['nb_persons'],
            'calculated_menu_price'  => $order['calculated_menu_price'],
            'delivery_fees'          => $order['delivery_fees'],
            'discount'               => $order['discount'],
            'total_price'            => $order['total_price'],
            'event_date'             => $order['event_date'],
            'validated_at'           => new UTCDateTime()
        ]);
    }

    // Nombre de commandes par menu
    public function getOrderCountByMenu(): array
    {
        $pipeline = [
            ['$group' => [
                '_id'   => '$menu_title',
                'count' => ['$sum' => 1],
                'total' => ['$sum' => '$total_price']
            ]],
            ['$sort' => ['count' => -1]]
        ];

        return iterator_to_array(
            $this->ordersCollection->aggregate($pipeline)
        );
    }

    // CA total
    public function getTotalRevenue(?string $dateFrom = null, ?string $dateTo = null): float
    {
        $match = [];

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
            '_id'   => null,
            'total' => ['$sum' => '$total_price']
        ]];

        $result = iterator_to_array(
            $this->ordersCollection->aggregate($pipeline)
        );

        return $result[0]['total'] ?? 0.0;
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
            '_id'          => ['menu_id' => '$menu_id', 'menu_title' => '$menu_title'],
            'total'        => ['$sum' => '$total_price'],
            'nb_orders'    => ['$sum' => 1],
            'avg_price'    => ['$avg' => '$total_price']
        ]];

        $pipeline[] = ['$sort' => ['total' => -1]];

        return iterator_to_array(
            $this->ordersCollection->aggregate($pipeline)
        );
    }
}