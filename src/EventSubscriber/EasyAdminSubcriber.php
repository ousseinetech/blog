<?php

namespace App\EventSubscriber;

use App\Entity\Category;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Cache\CacheInterface;

class EasyAdminSubcriber implements EventSubscriberInterface
{
   protected $cache;

   public function __construct(CacheInterface $cache)
   {
      $this->cache = $cache;
   }

   public static function getSubscribedEvents(): array
   {
      return [
         BeforeEntityPersistedEvent::class => ['setPostUpdate'],
         BeforeEntityUpdatedEvent::class => ['setSidebar'],
         BeforeEntityDeletedEvent::class => ['setSidebar']
      ];
   }

   /**
    * @throws InvalidArgumentException
    */
   public function setPostUpdate(BeforeEntityPersistedEvent $event)
   {
      $entity = $event->getEntityInstance();

      if ( !($entity instanceof Post || $entity instanceof Category) ) {
         return;
      }

      $entity->setUpdatedAt(new \DateTimeImmutable());
      $this->cache->delete('sidebar');
   }

   /**
    * @throws InvalidArgumentException
    */
   public function setSidebar()
   {
      $this->cache->delete('sidebar');
   }
}