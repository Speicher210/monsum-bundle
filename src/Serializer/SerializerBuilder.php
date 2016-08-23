<?php

namespace Speicher210\MonsumBundle\Serializer;

use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\SerializerBuilder as JMSSerializerBuilder;

/**
 * Builder for serializer instances.
 */
class SerializerBuilder extends JMSSerializerBuilder
{
    /**
     * Add a handler to the serializer.
     *
     * @param SubscribingHandlerInterface $handler The handler to add.
     * @return SerializerBuilder
     */
    public function addHandler(SubscribingHandlerInterface $handler)
    {
        $this->configureHandlers(
            function (HandlerRegistry $registry) use ($handler) {
                $registry->registerSubscribingHandler($handler);
            }
        );

        return $this;
    }
}
