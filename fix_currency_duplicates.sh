#!/bin/bash

# Fix duplicate currency code parameters in formatAmount calls
# This script will clean up the extra parameters and handle null values

echo "Fixing currency format calls..."

# Fix multiple currency code parameters - remove duplicates
find resources/views/admin -name "*.blade.php" -type f -exec sed -i 's/\$currencyService->formatAmount(\([^,]*\), \$userCurrency->code, \$userCurrency->code, \$userCurrency->code)/\$currencyService->formatAmount(\1 ?? 0, \$userCurrency->code)/g' {} \;

find resources/views/admin -name "*.blade.php" -type f -exec sed -i 's/\$currencyService->formatAmount(\([^,]*\), \$userCurrency->code, \$userCurrency->code)/\$currencyService->formatAmount(\1 ?? 0, \$userCurrency->code)/g' {} \;

# Handle some specific cases with null coalescing operator for amounts
find resources/views/admin -name "*.blade.php" -type f -exec sed -i 's/\$currencyService->formatAmount(\$order->subtotal ?? 0 ?? 0, \$userCurrency->code)/\$currencyService->formatAmount(\$order->subtotal ?? 0, \$userCurrency->code)/g' {} \;

find resources/views/admin -name "*.blade.php" -type f -exec sed -i 's/\$currencyService->formatAmount(\$order->total ?? 0 ?? 0, \$userCurrency->code)/\$currencyService->formatAmount(\$order->total ?? 0, \$userCurrency->code)/g' {} \;

echo "Currency format calls fixed!"