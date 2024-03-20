package configs

import (
	"context"
	"fmt"
	"log"
	"time"

	"go.mongodb.org/mongo-driver/bson"
	"go.mongodb.org/mongo-driver/bson/primitive"
	"go.mongodb.org/mongo-driver/mongo"
	"go.mongodb.org/mongo-driver/mongo/options"
)

type dbHandler interface {
    UpdateUser(id string, user User) (*mongo.UpdateResult, error)
}

type DB struct {
    client *mongo.Client
}

func NewDBHandler() dbHandler {
	if EnvMongoURI() == "" {
		panic("EnvMongoURI is null")
	}

	client, err := mongo.NewClient(options.Client().ApplyURI(EnvMongoURI()))
	if err != nil {
		panic(fmt.Sprintf("error creating new mongo client: %v", err))
	}

	ctx, cancel := context.WithTimeout(context.Background(), 10*time.Second)
	defer cancel()

	if err = client.Connect(ctx); err != nil {
		panic(fmt.Sprintf("error connecting to mongo: %v", err))
	}

	if err = client.Ping(ctx, nil); err != nil {
		panic(fmt.Sprintf("error pinging mongo: %v", err))
	}

	fmt.Println("Connected to MongoDB")

	return &DB{client: client}
}

func colHelper(db *DB) *mongo.Collection {
    if db == nil {
        log.Fatalf("db is null")
    }

    if db.client == nil {
        log.Fatalf("db.client is null")
    }

    return db.client.Database("teka_apps").Collection("users")
}

func (db *DB) UpdateUser(id string, user User) (*mongo.UpdateResult, error) {
    col := colHelper(db)
    ctx, cancel := context.WithTimeout(context.Background(), 10*time.Second)
    defer cancel()

    objId, _ := primitive.ObjectIDFromHex(id)

    update := bson.M{}

    // Periksa apakah bidang baru tidak kosong, jika ya, gunakan nilai baru
    if user.Name != "" {
        update["name"] = user.Name
    }
    if user.Email != "" {
        update["email"] = user.Email
    }
    
    if user.Diamond != 0 {
        update["diamond"] = user.Diamond
    }

    if user.Avatar != "" {
        update["avatar"] = user.Avatar
    }

    if user.PurchasedAvatars != nil {
        update["purchasedAvatars"] = user.PurchasedAvatars
    }

    // Jika tidak ada bidang yang baru tidak kosong, tidak perlu melakukan pembaruan
    if len(update) == 0 {
        return nil, nil
    }

    // Perbarui dokumen dengan menggunakan operasi $set pada MongoDB
    result, err := col.UpdateOne(ctx, bson.M{"_id": objId}, bson.M{"$set": update})

    if err != nil {
        return nil, err
    }

    return result, nil
}







