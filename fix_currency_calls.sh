#!/bin/bash

# Update all currency service calls to include the currency code parameter
find resources/views/admin -name "*.blade.php" -type f -exec sed -i 's/\$currencyService->formatAmount(\([^)]*\))/\$currencyService->formatAmount(\1, \$userCurrency->code)/g' {} \;

echo "Currency service calls updated!"