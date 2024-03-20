package models

import "go.mongodb.org/mongo-driver/bson/primitive"

type Diamond struct {
	ID       primitive.ObjectID `bson:"_id" json:"id"`
	Quantity int                `bson:"quantity" json:"quantity`
	Image    string             `bson:"image" json:"image`
	Price    int                `bson:"price" json:"price`
}
