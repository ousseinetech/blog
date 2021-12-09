<?php

namespace App\EventSubscriber;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;

class DataBaseEventSubscriber implements EventSubscriberInterface
{
   private CacheInterface $cache;

   public function __construct(CacheInterface $cache)
   {
      $this->cache = $cache;
   }

   public function getSubscribedEvents(): array
   {
      return [
         Events::preUpdate,
         Events::prePersist,
         Events::preRemove
      ];
   }

   /**
    * @throws InvalidArgumentException
    */
   public function preUpdate(LifecycleEventArgs $args)
   {
      $entity = $args->getObject();

      if (($entity instanceof Post)) {
         $entity->setUpdatedAt(new \DateTimeImmutable());
         $this->cache->delete('sidebar');
      } elseif (($entity instanceof Category)) {
         $this->cache->delete('sidebar');
         $this->cache->delete('dropdown');
      }

      return;
   }

   /**
    * @throws InvalidArgumentException
    */
   public function prePersist(LifecycleEventArgs $args)
   {
      $entity = $args->getObject();

      if (($entity instanceof Post)) {
         $entity->setUpdatedAt(new \DateTimeImmutable());
         $this->cache->delete('sidebar');
      } elseif (($entity instanceof Category)) {
         $this->cache->delete('sidebar');
         $this->cache->delete('dropdown');
      }

      return;
   }

   /**
    * @throws InvalidArgumentException
    */
   public function preRemove(LifecycleEventArgs $args)
   {
      $entity = $args->getObject();

      if (($entity instanceof Post)) {
         $this->cache->delete('sidebar');
      } elseif ( ($entity instanceof Category) ) {
         $this->cache->delete('sidebar');
         $this->cache->delete('dropdown');
      }

      return;
   }

}