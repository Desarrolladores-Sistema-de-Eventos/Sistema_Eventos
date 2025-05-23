# Sistema de Gestión de Cursos y Eventos Académicos - FISEI
#Descripción: 
Sistema web desarrollada para la gestión integral de eventos académicos (cursos, congresos, webinars o eventos académicos) en la Facultad de Ingeniería en Sistemas, Electrónica e Industrial. Permite administrar eventos, gestionar inscripciones, generar reportes y certificados, con un sistema de roles y control de acceso.

## 🚀 Funcionalidades Principales

- Gestión CRUD de eventos académicos, organizadores y participantes.
- Roles de usuario: Administrador, Participante, Responsable.
- Inscripción con verificación de requisitos.
- Generación de orden de pago y comprobantes.
- Carga y validación de comprobantes de pago.
- Generación de reportes de asistencia, notas y certificados.

📈 Evidencias de Desarrollo
![Vista principal del sistema](./public/img/Evidencia.png)

## 🧠 Tecnologías Utilizadas

- Lenguaje: PHP, JavaScript, 
- Frontend:Html, CSS, Bootstramp.  
- Base de datos: MySQL Server, PHPAdmin
- Control de versiones: Git + GitHub
- Gestión de cambios: Jira Service Management


## 📦 Estructura del Proyecto MVC

├── .vscode/ # Configuración de VSCode
├── config/ # Archivos de configuración (DB, constantes, etc.)
├── controllers/ # Controladores (MVC - lógica de control)
├── core/ # Núcleo del sistema (helpers, enrutador, clases base)
├── models/ # Modelos (MVC - acceso a datos, lógica de negocio)
├── public/ # Recursos públicos (CSS, JS, imágenes)
├── routes/ # Definición de rutas del sistema
├── vendor/ # Dependencias externas (Composer)
│
├── views/ # Vistas (MVC - interfaz de usuario)
│ ├── partials/ # Fragmentos reutilizables (headers, footers, etc.)|
│
├── .gitignore # Archivos/carpetas ignoradas por Git
├── auth.php # Lógica de autenticación
├── CONTRIBUTING.txt # Guía para colaboradores del proyecto
└── README.txt # Descripción general del proyecto

## 🧪 Instalación y Ejecución

1. Clona este repositorio:
git clone https://github.com/Desarrolladores-Sistema-de-Eventos/Sistema_Eventos.git
2. Instala las dependencias:
npm install / pip install composer


## 📖 Documentación Adicional
- [CONTRIBUTING.md]
---

## 👥 Equipo de Desarrollo

- Cristian Jurado
- Josue Llumitasig
- Andrea Vásquez
- Bryan López
- Dennis Quisaguano
- Ariel Cholota

## 📄 Licencia

Este proyecto es de uso académico y no cuenta con una licencia comercial.
