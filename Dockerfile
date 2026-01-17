# Usamos la imagen oficial de Nginx
FROM nginx:latest

# Copiamos TODO el contenido del repo a la carpeta html de Nginx
COPY . /usr/share/nginx/html

# Exponemos el puerto 80
EXPOSE 80

# Comando de inicio
CMD ["nginx", "-g", "daemon off;"]
