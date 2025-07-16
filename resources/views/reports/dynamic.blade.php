{{--
    Bienvenida a los reportes dinamicos

    # Cargar todas las tablas
    # Tener todos los filtros SQL posibles siguiendo esta estructura =
    SELECT columnas
    FROM tabla_principal
    [INNER | LEFT | RIGHT] JOIN otra_tabla ON condición
    WHERE condiciones
    GROUP BY columnas
    HAVING condiciones_de_agrupación
    ORDER BY columnas [ASC|DESC]
    LIMIT cantidad OFFSET inicio

    # opcion de grafica
--}}
