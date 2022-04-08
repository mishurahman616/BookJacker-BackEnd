from flask import Flask
import pandas as pd
import numpy as np
from nltk.corpus import stopwords
from sklearn.metrics.pairwise import linear_kernel
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.feature_extraction.text import TfidfVectorizer
from nltk.tokenize import RegexpTokenizer
import re
import string
import random
from PIL import Image
import requests
from io import BytesIO
import matplotlib.pyplot as plt
from sklearn.metrics.pairwise import cosine_similarity
from gensim.models import Word2Vec
from gensim.models.phrases import Phrases, Phraser
from matplotlib import pyplot
from gensim.models import KeyedVectors

app = Flask(__name__)


@app.route("/book/<string:name>")
def hello_world(name):
    title = name
    # Creating a list for storing the vectors (description into vectors)
    df = pd.read_csv("test.csv")

    def _removeNonAscii(s):
        return "".join(i for i in s if ord(i) < 128)

    def make_lower_case(text):
        return text.lower()

    def remove_stop_words(text):
        text = text.split()
        stops = set(stopwords.words("english"))
        text = [w for w in text if not w in stops]
        text = " ".join(text)
        return text

    def remove_html(text):
        html_pattern = re.compile('<.*?>')
        return html_pattern.sub(r'', text)

    def remove_punctuation(text):
        tokenizer = RegexpTokenizer(r'\w+')
        text = tokenizer.tokenize(text)
        text = " ".join(text)
        return text

    df['Desc'] = df['Desc'].astype(str)
    df['cleaned'] = df['Desc'].apply(_removeNonAscii)

    df['cleaned'] = df.cleaned.apply(func=make_lower_case)
    df['cleaned'] = df.cleaned.apply(func=remove_stop_words)
    df['cleaned'] = df.cleaned.apply(func=remove_punctuation)
    df['cleaned'] = df.cleaned.apply(func=remove_html)

    dff = pd.read_csv('word_embeddings.csv', delimiter=',')
    # User list comprehension to create a list of lists from Dataframe rows
    word_embeddings = [np.float32(list(row)) for row in dff.values]
    # Print list of lists i.e. rows

    cosine_similarities = cosine_similarity(word_embeddings, word_embeddings)
    books = df[['title', 'image_link']]
    indices = pd.Series(df.index, index=df['title']).drop_duplicates()

    idx = indices[title]
    sim_scores = list(enumerate(cosine_similarities[idx]))
    sim_scores = sorted(sim_scores, key=lambda x: x[1], reverse=True)
    sim_scores = sim_scores[1:6]
    book_indices = [i[0] for i in sim_scores]
    recommend = books.iloc[book_indices]
    names = ''
    for index, row in recommend.iterrows():
        names += row['title']+",<br />"
    print(recommend)

    return "<p>"+names+"</p>"


if __name__ == '__main__':
    app.run()
