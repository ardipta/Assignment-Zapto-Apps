import React from 'react';
import {Container, Nav, Navbar} from "react-bootstrap";
import {
    BrowserRouter as Router,
    Switch,
    Route,
    Link
} from "react-router-dom";
import Home from "./pages/Home";
import Register from "./pages/auth/Register";
import Login from "./pages/auth/Login";

const Master = () => {
    return (
        <>
            <Router>
                <Switch>
                    <Route path="/">
                        <Home />
                    </Route>
                    <Route path="/login">
                        <Login />
                    </Route>
                    <Route path="/register">
                        <Register />
                    </Route>
                </Switch>
                <Navbar bg="dark" variant="dark">
                    <Container>
                        <Navbar.Brand href="#home">Assignment Zapto Apps</Navbar.Brand>
                        <Nav className="mr-auto">
                            <Link to="/">Home</Link>
                        </Nav>
                        <Nav className="mr-auto">
                            <Link to="/login">Login</Link>
                        </Nav>
                        <Nav className="mr-auto">
                            <Link to="/register">Register</Link>
                        </Nav>
                    </Container>
                </Navbar>
            </Router>
        </>
    );
};

export default Master;