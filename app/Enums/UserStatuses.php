<?php

namespace App\Enums;

enum UserStatuses: int
{
   case ACTIVE = 1;
   case INACTIVE = 0;


   public function status(): string
   {
      return match ($this) {
         self::ACTIVE =>  'In',
         self::INACTIVE => 'Out',
      };
   }
}
