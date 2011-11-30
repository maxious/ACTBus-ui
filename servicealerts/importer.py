# info
# http://stackoverflow.com/questions/4206882/named-entity-recognition-with-preset-list-of-names-for-python-php/4207128#4207128
# http://alias-i.com/lingpipe/demos/tutorial/ne/read-me.html approximate dist
# http://streamhacker.com/2008/12/29/how-to-train-a-nltk-chunker/ more training
# http://www.postgresql.org/docs/9.1/static/pgtrgm.html

# data sources
# http://twitter.com/#!/ACTEmergencyInf instant site wide
# http://twitter.com/#!/ACTPol_Traffic
# http://esa.act.gov.au/feeds/currentincidents.xml

# source: https://gist.github.com/322906/90dea659c04570757cccf0ce1e6d26c9d06f9283
# to install python -m nltk.downloader punkt
import nltk
import tweepy
import psycopg2
import pickle

from iniparse import INIConfig

def insert_service_alert_sitewide(heading, message, url):
        print "NaN"

def insert_service_alert_for_street(streets, heading, message, url):
    	conn_string = "host='localhost' dbname='energymapper' user='postgres' password='snmc'"
	# print the connection string we will use to connect
	print "Connecting to database\n	->%s" % (conn_string)
	try:
		# get a connection, if a connect cannot be made an exception will be raised here
		conn = psycopg2.connect(conn_string)

		# conn.cursor will return a cursor object, you can use this cursor to perform queries
		cursor = conn.cursor()

		# execute our Query
		cursor.execute("")

		# retrieve the records from the database
		records = cursor.fetchall()

  	  	for record in records:
			ys.append(record[0])
                # >>> cur.execute("INSERT INTO test (num, data) VALUES (%s, %s)", (42, 'bar'))
                #>>> cur.statusmessage
                #'INSERT 0 1'
	except:
		# Get the most recent exception
		exceptionType, exceptionValue, exceptionTraceback = sys.exc_info()
		# Exit the script and print an error telling what happened.
		sys.exit("Database connection failed!\n ->%s" % (exceptionValue))
		

def extract_entity_names(t):
    entity_names = []
    
    if hasattr(t, 'node') and t.node:
        if t.node == 'NE':
            entity_names.append(' '.join([child[0] for child in t]))
        else:
            for child in t:
                entity_names.extend(extract_entity_names(child))
                
    return entity_names

def extract_names(sample):     
    sentences = nltk.sent_tokenize(sample)
    tokenized_sentences = [nltk.word_tokenize(sentence) for sentence in sentences]
    tagged_sentences = [nltk.pos_tag(sentence) for sentence in tokenized_sentences]
    chunked_sentences = nltk.batch_ne_chunk(tagged_sentences, binary=True)
    # chunked/tagged may be enough to just find and match the nouns

    entity_names = []
    for tree in chunked_sentences:
        # Print results per sentence
        # print extract_entity_names(tree)
        
        entity_names.extend(extract_entity_names(tree))

    # Print all entity names
    #print entity_names

    # Print unique entity names
    print set(entity_names)

cfg = INIConfig(open('/tmp/aws.ini'))

auth = tweepy.OAuthHandler(cfg.api_keys.twitter_consumer_key, cfg.api_keys.twitter_consumer_secret)
auth.set_access_token(cfg.api_keys.twitter_access_token, cfg.api_keys.twitter_access_token_secret)

#api = tweepy.API(auth)
api = tweepy.API()
# If the authentication was successful, you should
# see the name of the account print out
#print api.me().name
# https://github.com/tweepy/tweepy/blob/master/tweepy/api.py
for status in api.user_timeline(screen_name="ACTPol_Traffic",exclude_replies='true'):
            print status.text
            print status.created_at
            print extract_names(status.text)
# print api.update_status(status="test")

last_tweet_ids = { "lion": "111", "kitty": "2222" } 
pickle.dump( last_tweet_ids, open( "save.p", "wb" ) )
last_tweet_ids = pickle.load( open( "save.p", "rb" ) )