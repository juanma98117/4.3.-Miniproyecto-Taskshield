CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('empleado', 'tecnico', 'admin') NOT NULL DEFAULT 'empleado',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ;

CREATE TABLE tecnicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    FOREIGN KEY (id) REFERENCES usuarios(id) ON DELETE CASCADE
) ;

CREATE TABLE incidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('Alta', 'Media', 'Baja') NOT NULL DEFAULT 'Media',
    email VARCHAR(150) NOT NULL,
    estado ENUM('Pendiente', 'En Proceso', 'Resuelta') NOT NULL DEFAULT 'Pendiente',
    usuario_id INT NULL,
    tecnico_id INT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (tecnico_id) REFERENCES tecnicos(id) ON DELETE SET NULL
) ;

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Usuario Pruebas', 'test@taskshield.local', '1234', 'empleado'),
('Ana Gómez (Soporte)', 'ana.gomez@empresa.com', '1234', 'tecnico'),
('Carlos Pérez', 'carlos.perez@taskshield.local', '1234', 'tecnico'),
('Laura Martínez', 'laura.martinez@taskshield.local', '1234', 'tecnico'),
('David Sánchez', 'david.sanchez@taskshield.local', '1234', 'tecnico');

INSERT INTO tecnicos (nombre) VALUES
('Ana Gómez'),
('Carlos Pérez'),
('Laura Martínez'),
('David Sánchez');

INSERT INTO incidencias (titulo, descripcion, prioridad, estado, usuario_id, tecnico_id) VALUES
('Impresora Planta 2 no responde', 'La impresora muestra error de atasco de papel.', 'Media', 'Pendiente', 1, NULL),
('Monitor secundario parpadea', 'El monitor de la estacion 4 falla de forma intermitente.', 'Baja', 'En Proceso', 1, 2),
('Fallo general servidor correo', 'Ningun usuario puede enviar correos desde Outlook.', 'Alta', 'En Proceso', 1, 3);