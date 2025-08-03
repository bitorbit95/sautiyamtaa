<?php

namespace App\Console\Commands;

use App\Services\MpesaService;
use Illuminate\Console\Command;
use Exception;

class DebugMpesa extends Command
{
    protected $signature = 'mpesa:debug';
    protected $description = 'Debug M-Pesa configuration and connection';

    public function handle()
    {
        $this->info('M-Pesa Debug Tool');
        $this->info('================');

        // Check environment variables
        $this->checkEnvironmentVariables();
        
        // Test connection
        $this->testConnection();
        
        // Show configuration
        $this->showConfiguration();
    }

    private function checkEnvironmentVariables()
    {
        $this->info("\n1. Checking Environment Variables:");
        $this->line('-----------------------------------');

        $envVars = [
            'MPESA_ENVIRONMENT' => env('MPESA_ENVIRONMENT'),
            'MPESA_CONSUMER_KEY' => env('MPESA_CONSUMER_KEY'),
            'MPESA_CONSUMER_SECRET' => env('MPESA_CONSUMER_SECRET'),
            'MPESA_BUSINESS_SHORT_CODE' => env('MPESA_BUSINESS_SHORT_CODE'),
            'MPESA_PASSKEY' => env('MPESA_PASSKEY'),
            'MPESA_CALLBACK_URL' => env('MPESA_CALLBACK_URL'),
        ];

        foreach ($envVars as $key => $value) {
            if (empty($value)) {
                $this->error("❌ {$key}: NOT SET");
            } else {
                // Show partial values for security
                if (in_array($key, ['MPESA_CONSUMER_KEY', 'MPESA_CONSUMER_SECRET', 'MPESA_PASSKEY'])) {
                    $displayValue = substr($value, 0, 10) . '...' . substr($value, -4);
                } else {
                    $displayValue = $value;
                }
                $this->info("✅ {$key}: {$displayValue}");
            }
        }
    }

    private function testConnection()
    {
        $this->info("\n2. Testing M-Pesa Connection:");
        $this->line('------------------------------');

        try {
            $mpesaService = new MpesaService();
            $result = $mpesaService->testConnection();

            if ($result['success']) {
                $this->info("✅ " . $result['message']);
                $this->info("   Token length: " . $result['token_length'] . " characters");
            } else {
                $this->error("❌ " . $result['message']);
            }
        } catch (Exception $e) {
            $this->error("❌ Connection test failed: " . $e->getMessage());
        }
    }

    private function showConfiguration()
    {
        $this->info("\n3. Current Configuration:");
        $this->line('--------------------------');

        $config = config('mpesa');
        
        $this->table(
            ['Setting', 'Value'],
            [
                ['Environment', $config['environment']],
                ['Business Short Code', $config['business_short_code']],
                ['Callback URL', $config['callback_url']],
                ['Consumer Key', substr($config['consumer_key'] ?? '', 0, 10) . '...'],
                ['Consumer Secret', substr($config['consumer_secret'] ?? '', 0, 10) . '...'],
                ['Passkey', substr($config['passkey'] ?? '', 0, 10) . '...'],
            ]
        );

        $this->info("\n4. API URLs:");
        $this->line('------------');
        
        $urls = $config['urls'][$config['environment']] ?? [];
        foreach ($urls as $endpoint => $url) {
            $this->line("• {$endpoint}: {$url}");
        }

        $this->info("\n5. Troubleshooting Tips:");
        $this->line('------------------------');
        
        $this->line("• Ensure all environment variables are set in your .env file");
        $this->line("• For sandbox testing, use Safaricom's test credentials");
        $this->line("• Check that your callback URL is publicly accessible");
        $this->line("• Verify your business short code format (usually 6-7 digits)");
        $this->line("• Ensure your consumer key and secret are for the correct environment");
        
        if ($config['environment'] === 'sandbox') {
            $this->warn("\n⚠️  You're in SANDBOX mode. Use these test numbers:");
            $this->line("   • Phone: 254708374149");
            $this->line("   • PIN: Any 4-digit PIN");
        }
    }
}