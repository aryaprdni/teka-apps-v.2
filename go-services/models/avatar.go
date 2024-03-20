package models

import "go.mongodb.org/mongo-driver/bson/primitive"

type Avatar struct {
	ID          primitive.ObjectID `bson:"_id" json:"id"`
	Image       string             `bson:"image" json:"image"`
	Avatar_name string             `bson:"avatar_name" json:"avatar_name"`
	Price       string             `bson:"price" json:"price"`
}
