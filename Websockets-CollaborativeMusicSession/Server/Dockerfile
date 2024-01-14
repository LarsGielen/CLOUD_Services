# Build the JAR
FROM maven:3.8.4-openjdk-17 AS builder

WORKDIR /build

COPY pom.xml .
COPY src src

RUN mvn clean package

# Create image
FROM openjdk:17-jdk-alpine

WORKDIR /App

COPY --from=builder /build/target/*.jar server.jar

EXPOSE 80

ENTRYPOINT ["java", "-jar", "/App/server.jar"]
