lbaw2232

# Off The Shelf

This is it! The book you need, the experience you want, whenever you like.

## Project Components

- [ER: Requirements Specification](/docs/er.md)
- [EBD: Database Specification](/docs/ebd.md)
- [EAP: Architecture Specification and Prototype](/docs/eap.md)
- [PA: Product and Presentation](/docs/pa.md)

---

## Artefacts Checklist

- The artefacts checklist is available at: https://docs.google.com/spreadsheets/d/12nL0ETwC-9O1vw9y6Mdk9U8Dht9xw6nBLfkgmh79gzo/edit#gid=537406521

### Installation

- Link to the release (final version of source code): (https://git.fe.up.pt/lbaw/lbaw2223/lbaw2232/-/releases/pa)
- Docker command to start the image:
```
docker-compose up

docker run -it -p 8000:80 --name=lbaw2232 -e DB_DATABASE="lbaw2232" -e DB_SCHEMA="offtheshelf" -e DB_USERNAME="lbaw2232" -e DB_PASSWORD="dPSEDTRW" git.fe.up.pt:5050/lbaw/lbaw2223/lbaw2232
```

### Usage

URL to the product: http://lbaw2232.lbaw.fe.up.pt  

#### Administration Credentials

| Username  | Email       | Password   |
| ----------- | ----------- | ---------- |
| Diogo Silva | diogosilva@gmail.com | qwerty33  |

#### User Credentials

| Type          | Username  | Email  | Password |
| ------------- | --------- | --------- | -------- |
| basic account | Afonso Abreu | afonsoabreu@gmail.com    | 123aaa |
| basic account | Afonso Pinto | afonsopinto@gmail.com    | 456bbb |
| basic account | Ruben Monteiro | rubenmonteiro@gmail.com    | 789ccc |


## Team

- Afonso da Silva Pinto, up202008014@fe.up.pt
- Afonso José Pinheiro Oliveira Esteves Abreu, up202008552@fe.up.pt
- Diogo Filipe Ferreira da Silva, up202004288@fe.up.pt
- Rúben Lourinha Monteiro, up202006478@fe.up.pt

***
GROUP2232, 03/01/2022
