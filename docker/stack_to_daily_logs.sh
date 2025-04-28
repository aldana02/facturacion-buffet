#!/bin/bash

# Función para extraer la fecha del registro de error
extract_date() {
    local line="$1"
    local timestamp=$(echo "$line" | cut -d']' -f1 | cut -d'[' -f2)
    local date=$(date -d "$timestamp" +'%Y-%m-%d')
    echo "$date"
}

# Archivo de entrada
input_file="laravel.log"

# Carpeta donde se guardarán los archivos separados por fecha
output_folder="errores_por_fecha"

# Crear la carpeta de salida si no existe
mkdir -p "$output_folder"

# Variable para almacenar la fecha actual mientras se procesa el archivo
current_date=""

# Variable para controlar si se está procesando un stacktrace
in_stacktrace=false

# Leer el archivo de entrada línea por línea
while IFS= read -r line; do
    # Verificar si la línea contiene una fecha
    if [[ $line =~ \[([0-9-]+ [0-9:]+)\] ]]; then
        current_date="${BASH_REMATCH[1]}"
        # Cambiar el formato de la fecha a YYYY-MM-DD
        current_date=$(date -d "$current_date" +'%Y-%m-%d')
    fi
    
    # Verificar si la línea indica el inicio de un stacktrace
    if [[ $line =~ ^\[\w+\] ]]; then
        in_stacktrace=true
    fi

    # Nombre del archivo de salida
    output_file="$output_folder/laravel-$current_date.log"
    
    # Agregar la línea al archivo de salida
    echo "$line" >> "$output_file"
    
    # Verificar si se está procesando un stacktrace y si la línea está vacía para terminar el stacktrace
    if [ "$in_stacktrace" = true ] && [ -z "$line" ]; then
        in_stacktrace=false
    fi

done < "$input_file"

echo "Archivos separados por fecha creados en la carpeta '$output_folder'."
