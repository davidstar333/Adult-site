<?php

  use Illuminate\Database\Seeder;
  use App\Modules\Api\Models\SettingModel;
  use App\Modules\Api\Models\UserModel;
  use App\Modules\Api\Models\PaymentSettingModel;

  class DatabaseSeeder extends Seeder {

      /**
       * Run the database seeds.
       *
       * @return void
       */
      public function run() {

          $this->call('SettingTableSeeder');
          $this->command->info('Setting table seeded!');
          $this->call('UserTableSeeder');
          $this->command->info('User table seeded!');
          $this->call('PaymentSettingsTableSeeder');
          $this->command->info('Payment settings table seeded!');
          $this->call('ImportSql');
      }

  }

  class SettingTableSeeder extends Seeder {

      public function run() {
          DB::table('settings')->delete();

          SettingModel::create([
              'modelDefaultReferredPercent' => 20,
              'studioDefaultReferredPercent' => 20,
              'modelDefaultPerformerPercent' => 20,
              'studioDefaultPerformerPercent' => 20,
              'modelDefaultOtherPercent' => 20,
              'studioDefaultOtherPercent' => 20,
              'memberJoinBonus' => 5,
              'min_tip_amount' => 30,
              'mailFrom' => 'no-ryply@adentdemo.info',
              'conversionRate' => 1,
              'siteName' => ''
          ]);
      }

  }

  class UserTableSeeder extends Seeder {

      public function run() {
          DB::table('users')->delete();

          UserModel::create([
              'firstName' => 'Admin',
              'username' => 'admin',
              'email' => 'admin@yopmail.com',
              'emailVerified' => 1,
              'emailVerifyToken' => '',
              'passwordHash' => MD5('$Admin%1123'),
              'role' => 'admin',
              'accountStatus' => 'active'
          ]);
      }

  }

  class PaymentSettingsTableSeeder extends Seeder {

      /**
       * Run the database seeds.
       *
       * @return void
       */
      public function run() {
          //
          DB::table('paymentsettings')->delete();

          PaymentSettingModel::create([
              'name' => 'CCBill',
              'shortname' => 'CB',
              'description' => 'Pay by Credit Card',
              'currencyCode' => '840'
          ]);
      }

  }

  Class ImportSql extends Seeder {

      public function run() {
          DB::unprepared(File::get('database/cities.sql'));
          DB::unprepared(File::get('database/categories.sql'));
          DB::unprepared(File::get('database/countries.sql'));
          DB::unprepared(File::get('database/countries1.sql'));
          DB::unprepared(File::get('database/states.sql'));
          DB::unprepared(File::get('database/timezone.sql'));
          DB::unprepared(File::get('database/zone.sql'));
          DB::unprepared(File::get('database/ip2nation.sql'));
      }
  }
  