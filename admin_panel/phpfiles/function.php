<?php
function formatCurrency($amount, $options = []) {

    if (!class_exists('NumberFormatter')) {
        return 'Intl extension not enabled';
    }

    $locale = $options['locale'] ?? 'de_DE';
    $currency = $options['currency'] ?? 'EUR';

    $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

    return $formatter->formatCurrency((float)$amount, $currency);
}

?>