package models

import "go.mongodb.org/mongo-driver/bson/primitive"

type Quiz struct {
	ID       primitive.ObjectID `bson:"_id" json:"id"`
	Question string             `bson:"question" json:"question"`
	Answer   string             `bson:"answer" json:"answer"`
}
