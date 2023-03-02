#!/bin/bash

helpFunction()
{
   echo ""
   echo "Usage: $0 -n npmCommand"
   echo -n "-n Npm command"
   exit 1 # Exit script after printing help
}

while getopts "n:" opt
do
   case "$opt" in
      n ) NPMCOMMAND="$OPTARG" ;;
      ? ) helpFunction ;; # Print helpFunction in case parameter is non-existent
   esac
done

set +ex                     # immediate script fail off, echo off
export NVM_DIR="$HOME/.nvm" # set local path to NVM
. ~/.nvm/nvm.sh             # add NVM into the Shell session
nvm use 18  # choose current version
if [ -n "${NPMCOMMAND}" ]; then
  echo 'Npm command is set'
  npm ${NPMCOMMAND} #Run npm command
else
  echo 'Npm command is not set, exiting'
  helpFunction
  exit 1
fi

set -ex     # immediate script fail on (default), echo on (default)
