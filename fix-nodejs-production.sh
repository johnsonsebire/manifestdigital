#!/bin/bash

# Script to fix Node.js version on production server
# Run this on your production server to update Node.js to version 20.x

echo "=== Node.js Production Fix Script ==="
echo "Current Node.js version:"
node --version

echo "Installing Node.js 20.x from NodeSource repository..."

# Add NodeSource repository
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -

# Install Node.js
sudo apt-get install -y nodejs

echo "New Node.js version:"
node --version
npm --version

echo "Updating system symlinks..."
sudo ln -sf $(which node) /usr/bin/node
sudo ln -sf $(which npm) /usr/bin/npm

echo "Verification:"
echo "node location: $(which node)"
echo "npm location: $(which npm)"
echo "node version: $(node --version)"
echo "npm version: $(npm --version)"

echo "✓ Node.js update complete!"
echo "You can now retry your deployment."