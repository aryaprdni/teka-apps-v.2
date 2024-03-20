package mongodb

import (
	"context"
	"fmt"

	"go.mongodb.org/mongo-driver/bson"
	"go.mongodb.org/mongo-driver/mongo"
	"go.mongodb.org/mongo-driver/mongo/options"
)

// Define the global database name variable
var databaseName = "teka_apps"

// ConnectToMongoDB establishes a connection to MongoDB
func ConnectToMongoDB() (*mongo.Client, error) {
	clientOptions := options.Client().ApplyURI("mongodb+srv://aryaprdni:root@teka.cf0mmqo.mongodb.net/?retryWrites=true&w=majority&appName=teka")

	client, err := mongo.Connect(context.Background(), clientOptions)
	if err != nil {
		return nil, err
	}

	// Ping the MongoDB server to ensure connectivity
	err = client.Ping(context.Background(), nil)
	if err != nil {
		return nil, err
	}

	fmt.Println("Connected to MongoDB!")

	return client, nil
}

// createCollectionIfNotExists creates a collection if it doesn't exist
func CreateCollectionIfNotExists(database *mongo.Database, collectionName string) error {
	// Get the list of collections existing in the database
	collections, err := database.ListCollectionNames(context.Background(), bson.M{})
	if err != nil {
		return err
	}

	// Check if the collection already exists in the database
	for _, name := range collections {
		if name == collectionName {
			// Collection already exists, no need to create
			fmt.Println("Collection", collectionName, "already exists")
			return nil
		}
	}

	// Collection doesn't exist, create a new collection
	err = database.CreateCollection(context.Background(), collectionName)
	if err != nil {
		return err
	}

	fmt.Println("Collection", collectionName, "created successfully")
	return nil
}
