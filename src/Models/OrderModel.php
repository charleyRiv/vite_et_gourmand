<?php

class OrderModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare("
            SELECT
                co.order_date,
                co.event_date,
                co.delivery_time,
                co.delivery_street_number,
                co.delivery_street_name,
                co.delivery_zip_code,
                co.delivery_city,
                co.delivery_country,
                co.nb_persons,
                co.calculated_menu_price,
                co.delivery_fees,
                co.discount,
                co.total_price,
                co.current_status,
                co.material_lent
            FROM customer_order co
            JOIN user u ON co.user_id = u.user_id
            JOIN menu m ON co.menu_id = m.menu_id
            ORDER BY co.order_date ASC
        ");

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                co.order_id,
                co.user_id,
                co.menu_id,
                co.order_date,
                co.event_date,
                co.delivery_time,
                co.delivery_street_number,
                co.delivery_street_name,
                co.delivery_zip_code,
                co.delivery_city,
                co.delivery_country,
                co.nb_persons,
                co.calculated_menu_price,
                co.delivery_fees,
                co.discount,
                co.total_price,
                co.current_status,
                co.material_lent
            FROM customer_order co
            JOIN user u ON co.user_id = u.user_id
            JOIN menu m ON co.menu_id = m.menu_id
            WHERE co.order_id = :order_id
        ");

        $stmt->execute([':order_id' => $id]);
        return $stmt->fetch();
    }

    public function getAllWithFilters(array $filters = []): ?array
    {
        $conditions = [];
        $params = [];

        // Filtre par statut
        if (!empty($filters['status'])) {
            $conditions[] = 'co.current_status = :status';
            $params[':status'] = $filters['status'];
        }

        // Filtre par menu
        if (!empty($filters['menu_id'])) {
            $conditions[] = 'co.menu_id = :menu_id';
            $params[':menu_id'] = $filters['menu_id'];
        }

        //Filtre par date de prestation
        if (!empty($filters['date_from'])) {
            $conditions[] = 'co.event_date >= :date_from';
            $params[':date_from'] = $filters['date_from'];
        }

        if (!empty($filters['date_to'])) {
            $conditions[] = 'co.event_date <= :date_to';
            $params[':date_to'] = $filters['date_to'];
        }

        //Filtre par client
        if (!empty($filters['user_id'])) {
            $conditions[] = 'co.user_id = :user_id';
            $params[':user_id'] = $filters['user_id'];
        }


        //Construction de la clause WHERE
        $where = !empty($conditions)
            ? 'WHERE' . implode(' AND ', $conditions)
            : '';


        //requete
        $stmt = $this->db->prepare("
            SELECT
                co.order_id
                co.order_date,
                co.event_date,
                co.delivery_time,
                co.delivery_street_number,
                co.delivery_street_name,
                co.delivery_zip_code,
                co.delivery_city,
                co.delivery_country,
                co.nb_persons,
                co.calculated_menu_price,
                co.delivery_fees,
                co.discount,
                co.total_price,
                co.current_status,
                co.material_lent
                u.first_name,
                u.last_name,
                u.email,
                m.title AS menu_title
            FROM customer_order co
            JOIN user u ON co.user_id = u.user_id
            JOIN menu m ON co.menu_id = m.menu_id
            $where
            ORDER BY co.event_date ASC
        ");

        $stmt->execute([$params]);
        return $stmt->fetchAll();
    }

    public function getByStatus(string $current_status): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                co.order_date,
                co.event_date,
                co.delivery_time,
                co.delivery_street_number,
                co.delivery_street_name,
                co.delivery_zip_code,
                co.delivery_city,
                co.delivery_country,
                co.nb_persons,
                co.calculated_menu_price,
                co.delivery_fees,
                co.discount,
                co.total_price,
                co.current_status,
                co.material_lent
            FROM customer_order co
            JOIN user u ON co.user_id = u.user_id
            JOIN menu m ON co.menu_id = m.menu_id
            WHERE co.current_status = :current_status
            ORDER BY co.order_date ASC
        ");

        $stmt->execute([':current_status' => $current_status]);
        return $stmt->fetch();
    }
    public function createOrder(array $data): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO customer_order (
                event_date,
                delivery_time,
                delivery_street_number,
                delivery_street_type,
                delivery_street_name,
                delivery_zip_code,
                delivery_city,
                delivery_country,
                nb_persons,
                calculated_menu_price,
                delivery_fees,
                discount,
                total_price,
                current_status,
                material_lent,
                user_id,
                menu_id
            ) VALUES (
                :event_date,
                :delivery_time,
                :delivery_street_number,
                :delivery_street_type,
                :delivery_street_name,
                :delivery_zip_code,
                :delivery_city,
                :delivery_country,
                :nb_persons,
                :calculated_menu_price,
                :delivery_fees,
                :discount,
                :total_price,
                :current_status,
                :material_lent,
                :user_id,
                :menu_id
            )
        ");

        $stmt->execute([
            ':event_date' => $data['event_date'],
            ':delivery_time' => $data['delivery_time'],
            ':delivery_street_number' => $data['delivery_street_number'],
            ':delivery_street_type' => $data['delivery_street_type'],
            ':delivery_street_name' => $data['delivery_street_name'],
            ':delivery_zip_code' => $data['delivery_zip_code'],
            ':delivery_city' => $data['delivery_city'],
            ':delivery_country' => $data['delivery_country'],
            ':nb_persons' => $data['nb_persons'],
            ':calculated_menu_price' => $data['calculated_menu_price'],
            ':delivery_fees' => $data['delivery_fees'],
            ':discount' => $data['discount'],
            ':total_price' => $data['total_price'],
            ':current_status' => $data['current_status'],
            ':material_lent' => $data['material_lent'],
            ':user_id' => $data['user_id'],
            ':menu_id' => $data['menu_id']
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function updateStatus(int $id, array $data): int
    {
        $stmt = $this->db->prepare("
            UPDATE customer_order SET
                order_date = :order_date,
                event_date = :event_date,
                delivery_time = :delivery_time,
                delivery_street_number = :delivery_street_number,
                delivery_street_name = :delivery_street_name,
                delivery_zip_code = :delivery_zip_code,
                delivery_city = :delivery_city,
                delivery_country = :delivery_country,
                nb_persons = :nb_persons,
                calculated_menu_price = :calculated_menu_price,
                delivery_fees = :delivery_fees,
                discount = :discount,
                total_price = :total_price,
                current_status = :current_status,
                material_lent = :material_lent
            WHERE order_id = :id
        ");

        return $stmt->execute([
            ':order_date' => $data['order_date'],
            ':event_date' => $data['event_date'],
            ':delivery_time' => $data['delivery_time'],
            ':delivery_street_number' => $data['delivery_street_number'],
            ':delivery_street_name' => $data['delivery_street_name'],
            ':delivery_zip_code' => $data['delivery_zip_code'],
            ':delivery_city' => $data['delivery_city'],
            ':delivery_country' => $data['delivery_country'],
            ':nb_persons' => $data['nb_persons'],
            ':calculated_menu_price' => $data['calculated_menu_price'],
            ':delivery_fees' => $data['delivery_fees'],
            ':discount' => $data['discount'],
            ':total_price' => $data['total_price'],
            ':current_status' => $data['current_status'],
            ':material_lent' => $data['material_lent'],
            ':id' => $id
        ]);
    }


    public function deleteOrder(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM customer_order WHERE order_id = :order_id
        ");
        return $stmt->execute([':id' => $id]);
    }

    public function cancelOrder(int $id): bool
    {
        $stmt = $this->db->prepare("
        UPDATE customer_order SET
        current_status = 'cancelled'
        WHERE order_id = :id
        ");

        return $stmt->execute([':id' => $id]);
    }

    //Historique des statuts
    public function addStatusHistory(int $orderId, string $status, ?string $reason, ?string $contactMode): bool
    {
        $stmt = $this->db->prepare("
        INSERT INTO history_status_order(
            status,
            reason,
            contact_mode,
            order_id
        ) VALUES (
            :status,
            :reason,
            :contact_mode,
            :order_id)
        ");
        
        return $stmt->execute([
            ':status' => $status,
            ':reason' => $reason,
            ':contact_mode' => $contactMode,
            ':order_id' => $orderId 
        ]);
    }

    public function getStatusHistory(int $orderId): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                history_id,
                status,
                modified_at,
                reason,
                contact_mode,
                order_id
            FROM history_status_order
            WHERE orderId = :order_id
            ORDER BY modified_at ASC
        ");

        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetch();

    }

    public function discount(float $priceMenu): float
    {
        $discount = $priceMenu * 0.1 ;
        return $discount;
    }

    public function deliveryCharges(float $distance): float
    {
        $deliveryCharges = 5 + (floor($distance) * 0.59);
        return $deliveryCharges;
    }

}

?>