package main

import (
	"log"
	"net"

	pb "teka-apps/grpc/proto/user"

	"teka-apps/grpc/services"

	"google.golang.org/grpc"
)
func main() {
    lis, err := net.Listen("tcp", "[::1]:8080")
    if err != nil {
        log.Fatalf("failed to listen: %v", err)
    }

    grpcServer := grpc.NewServer()
    service := &services.UserServiceServer{}

    pb.RegisterUserServiceServer(grpcServer, service)
    err = grpcServer.Serve(lis)

    if err != nil {
        log.Fatalf("Error strating server: %v", err)
    }
}
