# Build application
FROM mcr.microsoft.com/dotnet/sdk:7.0 AS build
WORKDIR /source

COPY . .
RUN dotnet restore "MessageService.csproj"
RUN dotnet publish "MessageService.csproj" -c release -o /app --no-restore

# Run application
FROM mcr.microsoft.com/dotnet/aspnet:7.0 AS runtime
WORKDIR /app

RUN mkdir -p ./Database
COPY --from=build /app ./

EXPOSE 6060
EXPOSE 6061

ENTRYPOINT [ "dotnet", "MessageService.dll" ]