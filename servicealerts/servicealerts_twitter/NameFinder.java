InputStream modelIn = new FileInputStream("en-ner-person.bin");

try {
  TokenNameFinder model = new TokenNameFinderModel(modelIn);
}
catch (IOException e) {
  e.printStackTrace();
}
finally {
  if (modelIn != null) {
    try {
      modelIn.close();
    }
    catch (IOException e) {
    }
  }
}

NameFinderME nameFinder = new NameFinderME(model);

for (String document[][] : documents) {

  for (String[] sentence : document) {
    Span nameSpans[] = find(sentence);
    // do something with the names
  }

  nameFinder.clearAdaptiveData()
}


                InputStream in = getClass()
                        .getClassLoader()
                        .getResourceAsStream(
                                "opennlp/tools/namefind/AnnotatedSentences.txt");

                String encoding = "ISO-8859-1";

                ObjectStream<NameSample> sampleStream = new NameSampleDataStream(
                        new PlainTextByLineStream(new InputStreamReader(in,
                                encoding)));

                TokenNameFinderModel nameFinderModel = NameFinderME.train("en",
                        "default", sampleStream, Collections
                                .<String, Object> emptyMap(), 70, 1);

                TokenNameFinder nameFinder = new NameFinderME(nameFinderModel);

                // now test if it can detect the sample sentences

                String sentence[] = { "Alisa", "appreciated", "the", "hint",
                        "and", "enjoyed", "a", "delicious", "traditional",
                        "meal." };

                Span names[] = nameFinder.find(sentence);
