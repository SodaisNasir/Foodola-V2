<?php
function formatCurrency($amount, $options = []) {

    if (!class_exists('NumberFormatter')) {
        return 'Intl extension not enabled';
    }

    $locale = $options['locale'] ?? 'en_PK';
    $currency = $options['currency'] ?? 'PKR';

    $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);

    return $formatter->formatCurrency((float)$amount, $currency);
}

?>