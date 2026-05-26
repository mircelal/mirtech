<?php
declare(strict_types=1);

/** @return array<int, array<string, mixed>> */
function adminContentLangs(): array
{
    return enabledLangs();
}

function adminTr(array $entity, string $lang, string $field, mixed $default = ''): string
{
    $tr = $entity['translations'][$lang][$field] ?? null;
    if ($tr !== null && $tr !== '') {
        return (string)$tr;
    }
    if ($lang === defaultLang() && isset($entity[$field])) {
        return (string)$entity[$field];
    }
    return (string)$default;
}

function adminTrLines(array $entity, string $lang, string $field): string
{
    $tr = $entity['translations'][$lang][$field] ?? null;
    if (is_array($tr) && $tr !== []) {
        return implode("\n", array_map('strval', $tr));
    }
    if ($lang === defaultLang() && isset($entity[$field]) && is_array($entity[$field])) {
        return implode("\n", array_map('strval', $entity[$field]));
    }
    return '';
}

function adminSaveProjectTranslations(array $post, array $existing = []): array
{
    $translations = $existing['translations'] ?? [];
    if (!is_array($translations)) {
        $translations = [];
    }
    foreach (adminContentLangs() as $l) {
        $code = (string)($l['code'] ?? '');
        if ($code === '') {
            continue;
        }
        $pfx = 'tr_' . $code . '_';
        $translations[$code] = [
            'name' => trim($post[$pfx . 'name'] ?? ''),
            'desc' => trim($post[$pfx . 'desc'] ?? ''),
            'overview' => trim($post[$pfx . 'overview'] ?? ''),
            'category' => trim($post[$pfx . 'category'] ?? ''),
            'duration' => trim($post[$pfx . 'duration'] ?? ''),
            'features' => parseLines($post[$pfx . 'features'] ?? ''),
            'timeline' => adminParseTimelineFromPost($code, $post),
            'stats' => adminParseStatsFromPost($code, $post),
        ];
    }
    return $translations;
}

function adminParseTimelineFromPost(string $code, array $post): array
{
    $titles = $post['tl_title_' . $code] ?? [];
    $descs = $post['tl_desc_' . $code] ?? [];
    $progress = $post['tl_progress_' . $code] ?? [];
    $statuses = $post['tl_status_' . $code] ?? [];
    $out = [];
    if (!is_array($titles)) {
        return $out;
    }
    foreach ($titles as $i => $title) {
        $title = trim((string)$title);
        if ($title === '') {
            continue;
        }
        $out[] = [
            'title' => $title,
            'desc' => trim((string)($descs[$i] ?? '')),
            'progress' => max(0, min(100, (int)($progress[$i] ?? 0))),
            'status' => (string)($statuses[$i] ?? 'pending'),
        ];
    }
    return $out;
}

function adminParseStatsFromPost(string $code, array $post): array
{
    $labels = $post['st_label_' . $code] ?? [];
    $values = $post['st_value_' . $code] ?? [];
    $maxes = $post['st_max_' . $code] ?? [];
    $out = [];
    if (!is_array($labels)) {
        return $out;
    }
    foreach ($labels as $i => $label) {
        $label = trim((string)$label);
        $value = trim((string)($values[$i] ?? ''));
        if ($label === '' && $value === '') {
            continue;
        }
        $out[] = [
            'label' => $label,
            'value' => $value,
            'max' => max(1, (int)($maxes[$i] ?? 100)),
        ];
    }
    return $out;
}

function adminSaveServiceTranslations(array $post, array $existing = []): array
{
    $translations = $existing['translations'] ?? [];
    if (!is_array($translations)) {
        $translations = [];
    }
    foreach (adminContentLangs() as $l) {
        $code = (string)($l['code'] ?? '');
        if ($code === '') {
            continue;
        }
        $pfx = 'tr_' . $code . '_';
        $translations[$code] = [
            'title' => trim($post[$pfx . 'title'] ?? ''),
            'desc' => trim($post[$pfx . 'desc'] ?? ''),
            'price' => trim($post[$pfx . 'price'] ?? ''),
        ];
    }
    return $translations;
}

function adminSaveSettingsTranslations(array $post, array $existing = []): array
{
    $translations = $existing['translations'] ?? [];
    if (!is_array($translations)) {
        $translations = [];
    }
    foreach (adminContentLangs() as $l) {
        $code = (string)($l['code'] ?? '');
        if ($code === '') {
            continue;
        }
        $pfx = 'tr_' . $code . '_';
        $statValues = $post['tr_' . $code . '_stat_value'] ?? [];
        $statSuffixes = $post['tr_' . $code . '_stat_suffix'] ?? [];
        $statLabels = $post['tr_' . $code . '_stat_label'] ?? [];
        $statColors = $post['tr_' . $code . '_stat_color'] ?? [];
        $stats = [];
        if (is_array($statValues)) {
            foreach ($statValues as $i => $val) {
                $val = trim((string)$val);
                $label = trim((string)($statLabels[$i] ?? ''));
                if ($val === '' && $label === '') {
                    continue;
                }
                $stats[] = [
                    'value' => $val,
                    'suffix' => trim((string)($statSuffixes[$i] ?? '')),
                    'label' => $label,
                    'color' => (string)($statColors[$i] ?? 'blue'),
                ];
            }
        }
        $whyTitles = $post['tr_' . $code . '_why_title'] ?? [];
        $whyDescs = $post['tr_' . $code . '_why_desc'] ?? [];
        $whyIcons = $post['tr_' . $code . '_why_icon'] ?? [];
        $whyColors = $post['tr_' . $code . '_why_color'] ?? [];
        $why = [];
        if (is_array($whyTitles)) {
            foreach ($whyTitles as $wi => $wt) {
                $wt = trim((string)$wt);
                if ($wt === '') {
                    continue;
                }
                $why[] = [
                    'title' => $wt,
                    'desc' => trim((string)($whyDescs[$wi] ?? '')),
                    'icon' => (string)($whyIcons[$wi] ?? 'fa-star'),
                    'color' => (string)($whyColors[$wi] ?? 'blue'),
                ];
            }
        }
        if ($why === [] && !empty($existing['translations'][$code]['why'])) {
            $why = $existing['translations'][$code]['why'];
        }

        $translations[$code] = [
            'tagline' => trim((string)($post['tr_' . $code . '_tagline'] ?? '')),
            'hero_eyebrow' => trim((string)($post['tr_' . $code . '_hero_eyebrow'] ?? '')),
            'hero_title' => trim((string)($post['tr_' . $code . '_hero_title'] ?? '')),
            'hero_title_highlight' => trim((string)($post['tr_' . $code . '_hero_title_highlight'] ?? '')),
            'hero_subtitle' => trim((string)($post['tr_' . $code . '_hero_subtitle'] ?? '')),
            'stats' => $stats,
            'why' => $why,
            'included' => parseLines($post['tr_' . $code . '_included'] ?? ''),
        ];
    }
    return $translations;
}

function adminLangTabs(string $prefix = 'adm-lang', string $scope = 'content'): string
{
    $html = '<div class="' . $prefix . '-tabs" role="tablist" data-lang-scope="' . htmlspecialchars($scope) . '">';
    $def = defaultLang();
    foreach (adminContentLangs() as $i => $l) {
        $code = (string)($l['code'] ?? '');
        $label = (string)($l['native'] ?? $l['name'] ?? strtoupper($code));
        $active = ($code === $def || ($i === 0 && $def === '')) ? ' is-active' : '';
        $html .= '<button type="button" class="' . $prefix . '-tab' . $active . '" data-lang-tab="' . htmlspecialchars($code) . '" data-lang-scope="' . htmlspecialchars($scope) . '">' . htmlspecialchars($label) . '</button>';
    }
    $html .= '</div>';
    return $html;
}
