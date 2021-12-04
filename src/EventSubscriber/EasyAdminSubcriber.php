<?php

namespace App\EventSubscriber;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubcriber implements EventSubscriberInterface
{
   public static function getSubscribedEvents(): array
   {
      return [
         BeforeEntityPersistedEvent::class => ['setPostUpdate'],
      ];
   }

   public function setPostUpdate(BeforeEntityPersistedEvent $event)
   {
      $entity = $event->getEntityInstance();

      if ( !($entity instanceof Post) ) {
         return;
      }

      $entity->setUpdatedAt(new \DateTimeImmutable());
   }
}