FROM nginx 

WORKDIR /app

COPY . /app

EXPOSE 80

ENV NAME World 

CMD ["nginx", "-g", "daemon off;"]