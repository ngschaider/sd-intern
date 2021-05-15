#!/bin/sh
./yii migrate/up --migrationPath=@yii/rbac/migrations --interactive=0
./yii migrate --interactive=0
