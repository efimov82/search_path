Testing project to search journey path from start point to end point
Description task: Search Shortest path in an unweighted oriented graph

File with data: ./listCards.txt
Format file: 'from;to;time;transport;cost;seat;info'

Usage: php ./index.php 'New York JFK' 'Stockholm'

where first param - start point of journey
second param - end point of journey

Result:
```
Details your journey from 'New York JFK' to 'Stockholm': 
Variant #0 
#0: Take train from 'New York JFK" to "Madrid". Seat: 120 , Additional info:No
#1: Take flight A190 from 'Madrid" to "Gerona Airport". Seat: 25A , Additional info:info
#2: Take flight SK455 from 'Gerona Airport" to "Stockholm". Seat: 15A , Additional info:info
Total cost: 530$ 
Time in road: 600 min 
----------------------------------
Variant #1 
#0: Take moto from 'New York JFK" to "Barcelona". Seat:  no info , Additional info: -
#1: Take flight FT450 from 'Barcelona" to "Stockholm". Seat: No seat assignment , Additional info:info
Total cost: 650$ 
Time in road: 164 min 
----------------------------------
```

Run tests

php ./tests/testSearchPath.php