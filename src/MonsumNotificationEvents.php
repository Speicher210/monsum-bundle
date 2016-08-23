<?php

namespace Speicher210\MonsumBundle;

/**
 * Contains all events raised when an incoming Monsum notification comes.
 */
final class MonsumNotificationEvents
{
    const INCOMING_CUSTOMER_CREATED = 'speicher210_monsum.notification.incoming.customer.created';
    const INCOMING_CUSTOMER_CHANGED = 'speicher210_monsum.notification.incoming.customer.changed';
    const INCOMING_CUSTOMER_DELETED = 'speicher210_monsum.notification.incoming.customer.deleted';

    const INCOMING_SUBSCRIPTION_CREATED = 'speicher210_monsum.notification.incoming.subscription.created';
    const INCOMING_SUBSCRIPTION_CHANGED = 'speicher210_monsum.notification.incoming.subscription.changed';
    const INCOMING_SUBSCRIPTION_CANCELED = 'speicher210_monsum.notification.incoming.subscription.canceled';
    const INCOMING_SUBSCRIPTION_CLOSED = 'speicher210_monsum.notification.incoming.subscription.closed';
    const INCOMING_SUBSCRIPTION_REACTIVATED = 'speicher210_monsum.notification.incoming.subscription.reactivated';

    const INCOMING_PAYMENT_CREATED = 'speicher210_monsum.notification.incoming.payment.created';
    const INCOMING_PAYMENT_FAILED = 'speicher210_monsum.notification.incoming.payment.failed';
    const INCOMING_PAYMENT_CHARGEBACK = 'speicher210_monsum.notification.incoming.payment.chargeback';
    const INCOMING_PAYMENT_REFUNDED = 'speicher210_monsum.notification.incoming.payment.refunded';
}
