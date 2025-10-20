CREATE TABLE rol (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion VARCHAR(255),

    -- Auditoría
    usuario_creacion VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    usuario_modificacion VARCHAR(100),
    fecha_modificacion TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    
    usuario_eliminacion VARCHAR(100),
    fecha_eliminacion TIMESTAMP NULL,

    host_creacion VARCHAR(100),
    host_modificacion VARCHAR(100),
    host_eliminacion VARCHAR(100),

    estado INT DEFAULT 1  -- 1 = activo, 0 = inactivo (puedes ampliar a 2 = eliminado si deseas)
);
