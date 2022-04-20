<?php

    /**
     * An enum describing the possible status of an order.
     */
    enum OrdersStatus: string {
        case IN_PREPARATION = 'In preparazione';
        case SHIPPED = 'Spedito';
        case DELIVERY = 'In consegna';
        case DELIVERED = 'Consegnato';
    }

?>