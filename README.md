# replacement
Code Evaluation for Replacements Ltd.

My solution emphasizes an MVC framework, and a heirarchy of class structure that maintains a separation of concerns. Less emphasis was placed on the front-end styling of the solution.

All classes that need to store persistent data inherit from the DataStoreObject class. This class is completely independent of the type of Datastore that is used. Currently, there is only one DB technology implemented, and that is MySQL. If a different data storage type were to be used (such as NoSQL), all a developer would have to do is implement the DataAdapterInterface and specify the name of the new adapter (ie. "NoSQLAdapter") in the DataStoreObject class, under the $data_adapter property. No other change to the system would be required because all data technology specific code is encapsulated inside of the MysQL class.

There is a settings file where developers can easily alter the number of allowed requests, as well as input the database settings. There is aslo an SQL file in the db folder that can be used to upload a new database.

Given more time, there are several key improvements I would make:
 - Make a more dynamic autoloader that would handle namespace conventions and subfolders
 - Better data scrubbing and filtering. All data scrubbing takes place in the base MySQL Class.
 - Better Error checking and error reporting. Currently all errors just get sent to the log.
 - Instead of deleting record, records would be set to inactive.
 - An admin interface for adding new brand and types of pieces.
 - Email client for notifying the client of the request.
 
