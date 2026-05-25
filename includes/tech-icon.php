<?php
declare(strict_types=1);

/**
 * Texnologiya ikonları: devicon (nginx, mysql…) və ya Font Awesome brands/solid.
 * JSON: "icon": "devicon-docker-plain" VƏ YA "icon": "fa-docker", "icon_type": "brands"
 */

function techIconNormalize(array $t): array
{
    $icon = trim($t['icon'] ?? 'fa-code');
    $type = $t['icon_type'] ?? '';
    $brand = $t['brand'] ?? '';

    $fallbacks = [
        'laravel' => ['devicon', 'devicon-laravel-plain'],
        'vue' => ['devicon', 'devicon-vuejs-plain'],
        'node' => ['devicon', 'devicon-nodejs-plain'],
        'nodejs' => ['devicon', 'devicon-nodejs-plain'],
        'tailwind' => ['devicon', 'devicon-tailwindcss-plain'],
        'flutter' => ['devicon', 'devicon-flutter-plain'],
        'kotlin' => ['devicon', 'devicon-kotlin-plain'],
        'next' => ['devicon', 'devicon-nextjs-plain'],
        'nextjs' => ['devicon', 'devicon-nextjs-plain'],
        'proxmox' => ['solid', 'fa-server'],
        'nextcloud' => ['solid', 'fa-cloud'],
        'truenas' => ['solid', 'fa-hard-drive'],
        'almalinux' => ['solid', 'fa-linux'],
        'nginx' => ['devicon', 'devicon-nginx-original'],
        'mariadb' => ['devicon', 'devicon-mariadb-plain'],
        'mysql' => ['devicon', 'devicon-mysql-plain'],
        'apache' => ['devicon', 'devicon-apache-plain'],
        'docker' => ['devicon', 'devicon-docker-plain'],
        'git' => ['devicon', 'devicon-git-plain'],
        'redis' => ['devicon', 'devicon-redis-plain'],
        'postgres' => ['devicon', 'devicon-postgresql-plain'],
        'postgresql' => ['devicon', 'devicon-postgresql-plain'],
        'grafana' => ['devicon', 'devicon-grafana-original'],
        'portainer' => ['devicon', 'devicon-docker-plain'],
        'npm' => ['devicon', 'devicon-npm-original-wordmark'],
        'vite' => ['devicon', 'devicon-vitejs-plain'],
        'composer' => ['devicon', 'devicon-composer-line'],
        'bash' => ['solid', 'fa-terminal'],
        'prometheus' => ['solid', 'fa-chart-line'],
        'wireguard' => ['solid', 'fa-shield-halved'],
        'api' => ['solid', 'fa-plug'],
        'wordpress' => ['devicon', 'devicon-wordpress-plain'],
        'dle' => ['solid', 'fa-newspaper'],
        'javascript' => ['devicon', 'devicon-javascript-plain'],
        'typescript' => ['devicon', 'devicon-typescript-plain'],
        'dart' => ['devicon', 'devicon-dart-plain'],
        'java' => ['devicon', 'devicon-java-plain'],
        'go' => ['devicon', 'devicon-go-original-wordmark'],
        'rust' => ['devicon', 'devicon-rust-plain'],
        'csharp' => ['devicon', 'devicon-csharp-plain'],
        'ruby' => ['devicon', 'devicon-ruby-plain'],
        'swift' => ['devicon', 'devicon-swift-plain'],
        'scala' => ['devicon', 'devicon-scala-plain'],
        'r' => ['devicon', 'devicon-r-original'],
        'elixir' => ['devicon', 'devicon-elixir-plain'],
        'lua' => ['devicon', 'devicon-lua-plain'],
        'bash-lang' => ['devicon', 'devicon-bash-plain'],
        'objectivec' => ['devicon', 'devicon-objectivec-plain'],
        'html5' => ['devicon', 'devicon-html5-plain'],
        'css3' => ['devicon', 'devicon-css3-plain'],
        'haskell' => ['devicon', 'devicon-haskell-plain'],
        'dotnet' => ['devicon', 'devicon-dot-net-plain'],
        'php' => ['devicon', 'devicon-php-plain'],
        'python' => ['devicon', 'devicon-python-plain'],
        'cpp' => ['devicon', 'devicon-cplusplus-plain'],
        'aws' => ['devicon', 'devicon-amazonwebservices-plain'],
        's3' => ['devicon', 'devicon-amazonwebservices-plain'],
        'gcp' => ['devicon', 'devicon-googlecloud-plain'],
        'gcs' => ['devicon', 'devicon-googlecloud-plain'],
        'azure' => ['devicon', 'devicon-azure-plain'],
        'cloudflare' => ['devicon', 'devicon-cloudflare-plain'],
        'cloudflare-workers' => ['devicon', 'devicon-cloudflare-plain'],
        'cloudflare-r2' => ['devicon', 'devicon-cloudflare-plain'],
        'digitalocean' => ['devicon', 'devicon-digitalocean-plain'],
        'firebase' => ['devicon', 'devicon-firebase-plain'],
        'vercel' => ['devicon', 'devicon-vercel-plain'],
        'netlify' => ['devicon', 'devicon-netlify-plain'],
        'kubernetes' => ['devicon', 'devicon-kubernetes-plain'],
        'hetzner' => ['solid', 'fa-cloud'],
        'openai' => ['devicon', 'devicon-openai-original'],
        'chatgpt' => ['devicon', 'devicon-openai-original'],
        'gemini' => ['solid', 'fa-wand-magic-sparkles'],
        'claude' => ['solid', 'fa-message'],
        'tensorflow' => ['devicon', 'devicon-tensorflow-original'],
        'pytorch' => ['devicon', 'devicon-pytorch-original'],
        'langchain' => ['solid', 'fa-link'],
        'huggingface' => ['solid', 'fa-face-smile'],
        'ollama' => ['solid', 'fa-robot'],
    ];

    if (str_starts_with($icon, 'devicon-')) {
        return ['lib' => 'devicon', 'class' => $icon];
    }

    if ($type === 'devicon' || str_starts_with($icon, 'devicon')) {
        $cls = str_starts_with($icon, 'devicon-') ? $icon : 'devicon-' . $icon;
        return ['lib' => 'devicon', 'class' => $cls];
    }

    if ($brand && isset($fallbacks[$brand])) {
        [$lib, $cls] = $fallbacks[$brand];
        if ($lib === 'devicon') {
            return ['lib' => 'devicon', 'class' => $cls];
        }
        return ['lib' => 'solid', 'class' => $cls];
    }

    // Köhnə səhv ikonlar
    $wrong = [
        'fa-wind' => ['devicon', 'devicon-tailwindcss-plain'],
        'fa-node-js' => ['devicon', 'devicon-nextjs-plain'],
        'fa-flutter' => ['devicon', 'devicon-flutter-plain'],
    ];
    if (isset($wrong[$icon])) {
        [$lib, $cls] = $wrong[$icon];
        return ['lib' => 'devicon', 'class' => $cls];
    }

    if ($type === 'solid') {
        $cls = str_starts_with($icon, 'fa-') ? $icon : 'fa-solid fa-' . ltrim($icon, 'fa-');
        if (!str_contains($cls, 'fa-solid') && str_starts_with($cls, 'fa-')) {
            $cls = 'fa-solid ' . $cls;
        }
        return ['lib' => 'solid', 'class' => $cls];
    }

    $cls = str_starts_with($icon, 'fa-') ? $icon : 'fa-' . ltrim($icon, 'fa-');
    return ['lib' => 'brands', 'class' => $cls];
}

function renderTechIcon(array $t, string $extraClass = ''): string
{
    $n = techIconNormalize($t);
    $extra = trim($extraClass);
    if ($n['lib'] === 'devicon') {
        $cls = $n['class'] . ' colored tech-ico-devicon';
        if ($extra !== '') {
            $cls .= ' ' . $extra;
        }
        return '<i class="' . htmlspecialchars($cls) . '" aria-hidden="true"></i>';
    }
    if ($n['lib'] === 'solid') {
        $cls = $n['class'];
        if (!str_contains($cls, 'fa-solid')) {
            $cls = 'fa-solid ' . $cls;
        }
        if ($extra !== '') {
            $cls .= ' ' . $extra;
        }
        return '<i class="' . htmlspecialchars($cls) . '" aria-hidden="true"></i>';
    }
    $cls = 'fa-brands ' . $n['class'] . ' tech-ico-fa';
    if ($extra !== '') {
        $cls .= ' ' . $extra;
    }
    return '<i class="' . htmlspecialchars($cls) . '" aria-hidden="true"></i>';
}
