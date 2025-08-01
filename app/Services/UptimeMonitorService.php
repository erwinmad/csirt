<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\DaftarAplikasiModel;

class UptimeMonitorService
{
    public function getWebsitesToMonitor(): array
    {
        try {
            return DaftarAplikasiModel::query()
                ->where('is_active', true)
                ->where('is_featured', true)
                ->whereNotNull('url_aplikasi')
                ->pluck('url_aplikasi')
                ->map(function ($url) {
                    // Normalize URL - tambahkan scheme jika tidak ada
                    if (!preg_match('/^https?:\/\//i', $url)) {
                        $url = 'https://' . $url;
                    }
                    
                    $parsed = parse_url($url);
                    $host = $parsed['host'] ?? str_replace(['http://', 'https://'], '', $url);
                    return rtrim($host, '/');
                })
                ->filter()
                ->unique()
                ->values()
                ->toArray();
        } catch (\Exception $e) {
            Log::error('Failed to fetch websites to monitor: ' . $e->getMessage());
            return [];
        }
    }

    public function checkWebsiteStatus(string $website): array
    {
        $url = "https://{$website}";
        $startTime = microtime(true);
        
        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml'
                ])
                ->get($url);
                
            $responseTime = round((microtime(true) - $startTime) * 1000); // dalam ms
            $status = $response->successful() ? 'up' : 'down';
            
            Log::debug("Website check: {$website} - Status: {$status} - Response code: {$response->status()}");
            
            return [
                'status' => $status,
                'response_time' => $responseTime,
                'status_code' => $response->status(),
                'checked_at' => now()->toDateTimeString()
            ];
        } catch (\Exception $e) {
            Log::warning("Website check failed: {$website} - Error: " . $e->getMessage());
            
            return [
                'status' => 'down',
                'response_time' => null,
                'status_code' => 0,
                'checked_at' => now()->toDateTimeString(),
                'error' => $e->getMessage()
            ];
        }
    }

    public function checkWebsites(): array
    {
        $websites = $this->getWebsitesToMonitor();
        $results = [];
        
        foreach ($websites as $website) {
            $results[$website] = $this->checkWebsiteStatus($website);
        }
        
        Cache::put('website_uptime_status', $results, now()->addMinutes(15));
        return $results;
    }

    public function getStatus(): array
    {
        return Cache::remember('website_uptime_status', now()->addMinutes(15), function () {
            return $this->checkWebsites();
        });
    }
}