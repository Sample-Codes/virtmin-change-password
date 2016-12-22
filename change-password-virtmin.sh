#!/bin/bash
# USAGE:
#   ./vm-cp.sh user@domain.com oldpassword newpassword
echo -e "${2}\n${3}\n" | virtualmin change-password $1
