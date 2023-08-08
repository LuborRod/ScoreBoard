PHP Scoreboard Component

A lightweight, framework-independent PHP component for managing game scores using DDD approach. 
100% test coverage.

Notes - 

1) The use of SplObjectStorage in the Scoreboard Component is a deliberate design choice to ensure framework independence and to rely solely on native PHP implementations.

2) What TODO next?  
- When updating the score, ensure that the new score is greater than the previous score, as decreasing values are not permitted.
- Create StorageInterface, that we can choose any storage in future to replace current implementation.
- To implement Handler in Exceptions folder to handle and log all type of exceptions.

   
