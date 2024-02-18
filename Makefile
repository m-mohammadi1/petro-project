app.run:
	docker-compose --env-file ./src/.env up -d

app.down:
	docker-compose down

app.restart:
	docker-compose down && docker-compose --env-file ./src/.env up -d


app.build:
	docker-compose up --build

.PHONY: app.run app.down app.build app.restart