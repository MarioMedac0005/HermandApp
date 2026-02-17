<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stripe\StripeClient;

class StripeCleanAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todas las cuentas Express de Stripe';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stripeSecret = config('services.stripe.secret');

        if (!$stripeSecret) {
            $this->error('Stripe secret key no encontrada en .env');
            return;
        }

        $stripe = new StripeClient($stripeSecret);

        $this->info('Buscando cuentas Express en Stripe...');

        $startingAfter = null;
        $deletedCount = 0;

        do {

            $params = [
                'limit' => 100,
            ];

            // Solo añadir starting_after si existe
            if ($startingAfter) {
                $params['starting_after'] = $startingAfter;
            }

            $accounts = $stripe->accounts->all($params);

            foreach ($accounts->data as $account) {

                if ($account->type === 'express') {
                    try {
                        $stripe->accounts->delete($account->id);
                        $this->line("Eliminada: {$account->id}");
                        $deletedCount++;
                    } catch (\Exception $e) {
                        $this->warn("No se pudo eliminar: {$account->id}");
                    }
                }
            }

            $startingAfter = count($accounts->data)
                ? end($accounts->data)->id
                : null;

        } while ($accounts->has_more);


        $this->info("Proceso terminado. Cuentas eliminadas: {$deletedCount}");
    }
}
