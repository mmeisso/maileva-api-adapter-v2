#!/usr/bin/env bash

set -eux

ln -s /usr/local/bin/docker-entrypoint.sh /usr/local/bin/openapi-generator-cli

# list of openAPI spec url
declare -A urlList
urlList=(
  [Auth]=https://www.maileva.com/api/com-maileva-connect-authentication-v2-0-public.yaml
  [LrCopro]=https://www.maileva.com/api/api-real_estate-v1-37.yaml
)

for apiName in "${!urlList[@]}"; do
  pkgName=${apiName}Client
  url=${urlList[$apiName]}
  specFile=${pkgName}/spec.yaml
  openapiGeneratorConfigFile=${pkgName}/openapi-generator-config.yml
  openapiGeneratorIgnoreFile=${pkgName}/.openapi-generator-ignore

  # create prj directory
  mkdir -p ${pkgName}

  # get openapi spec file
  if [ ! -f $specFile ]; then
    wget -O $specFile ${url}
  fi

  # create openapi-generator config file
  if [ ! -f $openapiGeneratorConfigFile ]; then
    cat <<EOF >$openapiGeneratorConfigFile
# https://openapi-generator.tech/docs/generators/php
inputSpec: $specFile
outputDir: ${pkgName}
generatorName: php
invokerPackage: MailevaApiAdapter\\App\\Client\\${pkgName}
packageName: ${pkgName}
srcBasePath: /
variableNamingConvention: camelCase
EOF
  fi

  # create .openapi-generator-ignore file
  if [ ! -f $openapiGeneratorIgnoreFile ]; then
    cat <<EOF >$openapiGeneratorIgnoreFile
# https://openapi-generator.tech/docs/customization/#ignore-file-format
.gitignore
.openapi-generator-ignore
.php-cs-fixer.dist.php
.travis.yml
composer.*
git_push.sh
phpunit.xml.dist
README.md

test/
.openapi-generator/
EOF
  fi

done

# generate api client
openapi-generator-cli batch ./*/openapi-generator-config.yml

# give right X
chown -hR 1000:1000 /local
