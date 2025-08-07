# مرحلة البناء (Builder)
FROM node:20 AS builder

# تعيين مجلد العمل
WORKDIR /app

# نسخ ملفات البروجكت
COPY . .

# تعريف المتغير الشرطي للبناء
ARG SKIP_BUILD=false

# تنفيذ build إذا لم يكن SKIP_BUILD = true
RUN echo "SKIP_BUILD=$SKIP_BUILD" && \
    npm install && \
    if [ "$SKIP_BUILD" != "true" ]; then \
        npm run build; \
    else \
        echo "Skipping build step"; \
    fi


# مرحلة التشغيل (Production)
FROM node:20 AS production

# تعيين مجلد العمل
WORKDIR /app

# نسخ الملفات من مرحلة البناء
COPY --from=builder /app /app

# تثبيت الحزم فقط (production)
RUN npm install --omit=dev

# تعيين البورت الافتراضي
EXPOSE 3000

# أمر التشغيل الرئيسي
CMD ["npm", "start"]
