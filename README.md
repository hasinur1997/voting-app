# Poll and Voting App

## Description

This is a Poll and Voting application that allows users to participate in polls by voting for their preferred options. It ensures that each user can vote only once, and the results are displayed in real-time. The system is built with Laravel and supports WebSocket-based real-time updates using Pusher.

## Features

- **Poll Creation**: Admin can create polls with multiple options.
- **Voting System**: Users can vote for a single option in a poll.
- **Real-time Voting**: Votes are updated and displayed in real-time using WebSocket.
- **Vote Limitation**: Users can only vote once per poll.
- **API Endpoint**: Provides an API for voting via POST request.
- **Database Integration**: Data is stored in MySQL for polls, options, and votes.

## Installation

```bash
git clone https://github.com/hasinur1997/voting-app.git

```

```bash
cd voting-app

```

```sh
composer install
```

```sh
npm install && npm run build
```

### For websocket configuration

Please update .env file following environments variables.

BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_app_key
PUSHER_APP_SECRET=your_pusher_app_secret
PUSHER_APP_CLUSTER=your_pusher_app_cluster
PUSHER_PORT=443
PUSHER_SCHEME="https"

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"


### To test real-time functionality

1. Login 
2. Go to poll list
3. Get sharebale link from the one of poll list and visit the link
![Poll Link](https://drive.google.com/uc?export=view&id=1Z-6C-vUg-qK2GjkveYBhjqfldGKnk7A5)
4. View the poll that you visit poll link in one browser tab
![Single poll view](https://drive.google.com/uc?export=view&id=1GXR7wmDJwsqCnS7Hal3h6v6RicyHqdBX)
5. In another tab submit vote from the link and you will see automatically update vote count
![Vote submit](https://drive.google.com/uc?export=view&id=1PEfijoHddSHtYwx2qsIGwgryaNeh8wGB)

After submiting vote please go single poll view and you see automatically update votecoutn without page


