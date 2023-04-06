FROM nginx:alpine

# ARG USER_ID
# ARG GROUP_ID

# RUN apk add --no-cache shadow
# RUN usermod -u ${USER_ID} nginx \
#   && groupmod -g ${GROUP_ID} nginx

#COPY ./.docker/config/nginx/default.conf /etc/nginx/conf.d/

COPY ./config/nginx/default.conf /etc/nginx/conf.d/default.conf
#COPY . .

# COPY ${APP_PATH_HOST_BACK}  ${APP_PATH_CONTAINER_BACK}
