4.3 - Miniproyecto TaskShield

**Estructura de archivos**

El proyecto está montado con los siguientes ficheros:

**config.php:** Guarda los datos de conexión a la base de datos.

**conexion.php:** Prepara la conexión con PDO y asegura las consultas para evitar inyecciones SQL.

**index.php:** El panel principal donde se listan las incidencias activas, se pueden cambiar los técnicos, editar o borrar las incidencias.

**nueva_incidencia.php:** El formulario para registrar una nueva incidencia.

**editar_incidencia.php:** La vista y la lógica para modificar los datos de una incidencia ya creada.

**eliminar_incidencia.php:** Se encarga de borrar el registro de la base de datos de forma segura.

**asignar_incidencia.php:** Procesa la asignación del técnico a cada incidencia.

**styles.css**: Hoja de estilos generada con asistencia de IA y adaptada para mantener una interfaz limpia y funcional.

**doc/schema.sql**: Script de creación de la base de datos con tablas relacionales (`usuarios`, `tecnicos`, `incidencias`) y datos iniciales de prueba.

**Cómo probarlo**

**Requisitos:** Tener XAMPP funcionando con PHP y MySQL.

**Base de datos:**

**1.**Crea una base de datos llamada taskshield.

**2.**Importa el archivo schema.sql que viene en la carpeta doc.

**Configuración:** Comprueba que los datos de acceso en config.php coinciden con los de tu entorno local, es decir, que tenga el mismo nombre y misma contraseña.

**Ejecución:** Clona mi repositorio en tu equipo, copia la carpeta del proyecto dentro de htdocs en XAMPP y ábrelo en el navegador, por ejemplo: http://localhost/nombre de tu carpeta/nombre de tu carpeta/index.php.