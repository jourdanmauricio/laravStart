# !/bin/bash
#
# integriprod_categorias_ml
#
# Proceso batch para invocar la API de mercado libre:
# - obtener el listado de categerías principales
#    y el archivo árbol de dependencias
#
# Ejecución on-line y cron diria
#
# Archivos categoriesMLA y categorias.json
#

URL_BASE="/var/www/html/laravel/larastart"
LOGFILE=$URL_BASE"/storage/logs/integriprod_categorias_ml.log"
FICHERO=$URL_BASE"/files/categoriesMLA"
FICHERO_JSON=$URL_BASE"/files/categorias.json"
FICHERO_OLD=$URL_BASE"/files/categorias.old"
FICHERO_GZ=$URL_BASE"/files/categoriesMLA.gz"
FICHERO_CAT=$URL_BASE"/files/categoriesMLA"
FICHERO_CAT_PPAL=$URL_BASE"/files/categorias_ppal.json"
FICHERO_CAT_PPAL_OLD=$URL_BASE"/files/categorias_ppal.old"

echo "*********************************" > $LOGFILE
echo "*** integriprod_categorias_ml ***" >> $LOGFILE
echo "*********************************" >> $LOGFILE

echo "$(date "+%m%d%Y %T") : Starting work" >> $LOGFILE

if [ -f $FICHERO_CAT_PPAL ]
 then
    echo "Renombrando archivo $FICHERO_CAT_PPAL a .old" >> $LOGFILE
    mv $FICHERO_CAT_PPAL $FICHERO_CAT_PPAL_OLD
 fi

echo "$(date "+%m%d%Y %T") : Starting descarga categorias" >> $LOGFILE
curl https://api.mercadolibre.com/sites/MLA/categories/all > $FICHERO_GZ

if [ $? -eq 0 ]
then
  echo "$(date "+%m%d%Y %T") : Finish descarga categorias OK" >> $LOGFILE
  echo "Descomprimiendo $FICHERO_GZ" >> $LOGFILE
  gzip -d $FICHERO_GZ
else
  echo "$(date "+%m%d%Y %T") : ERROR: descarga categorias" >> $LOGFILE
  exit 1
fi

echo "$(date "+%m%d%Y %T") : Start create $FICHERO_JSON" >> $LOGFILE
jq 'del(.[].settings, .[].picture, .[].permalink, .[].attribute_types, .[].meta_categ_id, .[].attributable, .[].path_from_root)' $FICHERO_CAT > $FICHERO_JSON

if [ $? -eq 0 ]
 then
   echo "$(date "+%m%d%Y %T") : Finish create $FICHERO_JSON OK" >> $LOGFILE
 else
   echo "$(date "+%m%d%Y %T") : ERROR: create $FICHERO_JSON OK" >> $LOGFILE
   exit 1
 fi

if [ -f $FICHERO ]
    then
    echo "Eliminado archivo $FICHERO anterior" >> $LOGFILE
    rm -f $FICHERO
fi

echo "$(date "+%m%d%Y %T") : Starting descarga categorias principales" >> $LOGFILE
curl https://api.mercadolibre.com/sites/MLA/categories > $FICHERO_CAT_PPAL

if [ $? -eq 0 ]
then
  echo "$(date "+%m%d%Y %T") : Finish descarga categorias principales OK" >> $LOGFILE
else
  echo "$(date "+%m%d%Y %T") : ERROR: descarga categorias principales" >> $LOGFILE
  exit 1
fi

echo "$(date "+%m%d%Y %T") : Finish work" >> $LOGFILE
