<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create(
            [
                "user_id" => "2",
                "pay_id" => "pay_080225913252",
                "dateCreated" => "2017-03-10",
                "customer" => "cus_G7Dvo4iphUNk",
                "paymentLink" => null,
                "installment" => "5a2c890b-dd63-4b5a-9169-96c8d7828f4c",
                "dueDate" => "2017-06-10",
                "value" => 20,
                "netValue" => 15,
                "billingType" => "BOLETO",
                "status" => "PENDING",
                "description" => "Pedido 056984",
                "externalReference" => "056984",
                "installmentNumber" => 3,
                "invoiceUrl" => "https =>//www.asaas.com/i/080225913252",
                "bankSlipUrl" => "https =>//www.asaas.com/b/pdf/080225913252",
                "invoiceNumber" => "00005101",
            ]);
    }
}
