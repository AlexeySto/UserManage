FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]