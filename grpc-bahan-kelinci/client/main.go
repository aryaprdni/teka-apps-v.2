package main

import (
	"context"
	"fmt"
	"log"
	"time"

	pb "teka-apps/learn-grpc/student"

	"google.golang.org/grpc"
)

func getDataStudentByEmail(client pb.DataStudentClient, email string) {
	ctx, cancel := context.WithTimeout(context.Background(), 10*time.Second)
	defer cancel()

	s := pb.Student{Email: email}
	student, err := client.FindStudentByEmail(ctx, &s)
	if err != nil {
		log.Fatalln("error in find student by email")
	}
	fmt.Println(student)
}

func main() {
	var opts []grpc.DialOption

	opts = append(opts, grpc.WithInsecure())
	opts = append(opts, grpc.WithBlock())

	conn, err := grpc.Dial(":1200", opts...)
	if err != nil {
		log.Fatalln("error in dial")
	}

	defer conn.Close()
	client := pb.NewDataStudentClient(conn)
	getDataStudentByEmail(client, "ja@j.com")
	getDataStudentByEmail(client, "jawd@j.com")
}