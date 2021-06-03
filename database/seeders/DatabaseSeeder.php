<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AllcountryTableSeeder::class);
        $this->call(AllstatesTableSeeder::class);
        $this->call(AllcitiesTableSeeder::class);
        $this->call(AutoDetectGeosTableSeeder::class);
        $this->call(BankDetailsTableSeeder::class);
        $this->call(CommissionSettingsTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);
        $this->call(CurrencyListTableSeeder::class);
        $this->call(DashboardSettingsTableSeeder::class);
        $this->call(GenralsTableSeeder::class);
        $this->call(InvoicesTableSeeder::class);
        $this->call(FootersTableSeeder::class);
        $this->call(SeosTableSeeder::class);
        $this->call(ShippingsTableSeeder::class);
        $this->call(ShippingWeightsTableSeeder::class);
        $this->call(SocialsTableSeeder::class);
        $this->call(SpecialOfferWidgetTableSeeder::class);
        $this->call(WidgetsettingsTableSeeder::class);
        $this->call(UnitsTableSeeder::class);
        $this->call(UnitValuesTableSeeder::class);
        $this->call(AbusedsTableSeeder::class);
        $this->call(LocalesTableSeeder::class);
        $this->call(ThemeSettingsTableSeeder::class);
        $this->call(WhatsappSettingsTableSeeder::class);
        $this->call(OfferPopupsTableSeeder::class);
        $this->call(PWASettingsTableSeeder::class);
        $this->call(AffilatesTableSeeder::class);
    }
}
