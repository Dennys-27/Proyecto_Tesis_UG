CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_rol INT NOT NULL, -- relación con la tabla rol
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    clave VARCHAR(255) NOT NULL, -- se recomienda almacenar hash, no texto plano
    telefono VARCHAR(20),
    
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

    estado INT DEFAULT 1, -- 1 = activo, 0 = inactivo, 2 = eliminado

    CONSTRAINT fk_usuario_rol FOREIGN KEY (id_rol) REFERENCES rol(id_rol)
);
