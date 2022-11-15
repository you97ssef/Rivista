import 'package:flutter/material.dart';
import 'package:rivista/screens/home.dart';

class Rivista extends StatelessWidget {
  const Rivista({
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Rivista App',
      theme: ThemeData.dark().copyWith(
        appBarTheme: AppBarTheme(color: Colors.grey[900]),
      ),
      home: const Home(
        title: 'Rivista',
      ),
      routes: const {},
    );
  }
}
