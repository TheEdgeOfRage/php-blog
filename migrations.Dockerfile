FROM alpine:3.14

RUN apk add --no-cache mysql-client

ENTRYPOINT [ "/migrations_entrypoint.sh" ]
COPY ./init.sql ./docker/migrations_entrypoint.sh /
