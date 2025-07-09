FROM nginx:alpine

# Copy nginx configuration
COPY docker/development/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/development/nginx/default.conf /etc/nginx/conf.d/default.conf

# Create the directory for storing logs
RUN mkdir -p /var/log/nginx

# Change ownership of the application directory
RUN chown -R nginx:nginx /var/www/html

# Expose port 80
EXPOSE 80

# Start nginx
CMD ["nginx", "-g", "daemon off;"]
