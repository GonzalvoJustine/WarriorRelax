<?php


namespace App\Factory;


use App\Entity\Order;
use App\Entity\Exercise;
use App\Entity\OrderItem;

/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Order
     */
    public function create(): Order
    {
        $order = new Order();
        $order
            ->setStatus(Order::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $order;
    }

    /**
     * Creates an item for a product.
     *
     * @param Exercise $exercise
     *
     * @return OrderItem
     */
    public function createItem(Exercise $exercise): OrderItem
    {
        $item = new OrderItem();
        $item->setExercise($exercise);
        $item->setQuantity(1);

        return $item;
    }
}
