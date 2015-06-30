#!/bin/sh

cp contrib/hooks/pre-commit .git/hooks/pre-commit
cp contrib/hooks/post-checkout .git/hooks/post-checkout
chmod +x .git/hooks/pre-commit
chmod +x .git/hooks/post-checkout